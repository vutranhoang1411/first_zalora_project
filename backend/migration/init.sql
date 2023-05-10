start transaction;
create table product(
    id int not null auto_increment,
    name varchar(100) not null,
    brand varchar(100) not null,
    sku varchar(20) not null,
    size varchar(5) not null,
    color varchar(20) not null,
    status enum('active','inactive') not null default 'active',
    total_stock int not null default 0,
    primary key (id)
);

create table supplier(
    id int not null auto_increment,
    name varchar(100) not null,
    email varchar(40) not null unique,
    number varchar(20) not null,
    total_stock int not null default 0,
    status enum('active','inactive') not null default 'active',
    primary key (id)
);
create table address(
    id int not null auto_increment,
    addr varchar(100) not null,
    type enum('office','warehouse','headquater') not null,
    supplierid int not null,
    primary key (id),
    foreign key (supplierid) references supplier(id) on delete cascade
);
create table productsupply (
    id int not null auto_increment,
    productid int not null,
    supplierid int not null,
    stock int not null default 0,
    primary key (id),
    foreign key (productid) references product(id) on delete cascade,
    foreign key (supplierid) references supplier(id) on delete cascade
);

-- insert product supply trigger
delimiter $$
create trigger insert_product_supply
after insert on productsupply
for each row
begin
    update product
    set total_stock=total_stock+NEW.stock
    where product.id=NEW.productid;

    update supplier
    set total_stock=total_stock+NEW.stock
    where supplier.id=NEW.supplierid;
end$$
delimiter ;

-- update product supply trigger
delimiter $$
create trigger update_product_supply
after update on productsupply
for each row
begin
    update product
    set total_stock=total_stock+(NEW.stock-OLD.stock)
    where product.id=NEW.productid;

    update supplier
    set total_stock=total_stock+(NEW.stock-OLD.stock)
    where supplier.id=NEW.supplierid;
end$$
delimiter ;

-- delete product supply trigger
delimiter $$
create trigger delete_product_supply
after delete on productsupply
for each row
begin
    update product
    set total_stock=total_stock-OLD.stock
    where product.id=OLD.productid;

    update supplier
    set total_stock=total_stock - OLD.stock
    where supplier.id=OLD.supplierid;
end$$
delimiter ;

commit;
