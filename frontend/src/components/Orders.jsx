import * as React from 'react';
import Link from '@mui/material/Link';
import Title from './Title';
import { DataGrid } from '@mui/x-data-grid';

// Generate Order Data
// GridColDef[]
const columns = [
  { field: 'name', headerName: 'Name', width: 200},
  { field: 'brand', headerName: 'Brand', width: 100 },
  { field: 'sku', headerName: 'SKU', width: 100 },
  {
    field: 'size',
    headerName: 'Size',
    type: 'number',
    width: 90,
  },
  {
    field: 'supplier',
    headerName: 'Supplier',
    description: 'This column has a value getter and is not sortable.',
    sortable: false,
    width: 160,
    // valueGetter: (params) => // GridValueGetterParams
    //   `${params.row.firstName || ''} ${params.row.lastName || ''}`,
  },
  { field: 'color', headerName: 'Color', width: 100, editable: true },
  { field: 'status', headerName: 'Status', width: 70, editable: true },
  { field: 'stock', headerName: 'Stock', type: 'number', width: 70 },

];

const rows = [
  {id: 1, name: 'HM Winter Sweater', brand: 'HM', sku: 'HM0923SW', size: 'XXL', supplier: 'Zalora Warehouse', color: 'Green', status: 'Enable', stock: 1290},
  {id: 2, name: 'HM Winter Sweater', brand: 'HM', sku: 'HM0923SW', size: 'XXL', supplier: 'Zalora Warehouse', color: 'Green', status: 'Enable', stock: 1290},
  {id: 3, name: 'HM Winter Sweater', brand: 'HM', sku: 'HM0923SW', size: 'XXL', supplier: 'Zalora Warehouse', color: 'Green', status: 'Enable', stock: 1290},
  {id: 4, name: 'HM Winter Sweater', brand: 'HM', sku: 'HM0923SW', size: 'XXL', supplier: 'Zalora Warehouse', color: 'Green', status: 'Enable', stock: 1290},
  {id: 5, name: 'HM Winter Sweater', brand: 'HM', sku: 'HM0923SW', size: 'XXL', supplier: 'Zalora Warehouse', color: 'Green', status: 'Enable', stock: 1290},
  {id: 6, name: 'HM Winter Sweater', brand: 'HM', sku: 'HM0923SW', size: 'XXL', supplier: 'Zalora Warehouse', color: 'Green', status: 'Enable', stock: 1290},
];

function preventDefault(event) {
  event.preventDefault();
}

export default function Orders() {
  return (
    <React.Fragment>
      <Title>Recent Orders</Title>
      <DataGrid
        rows={rows}
        columns={columns}
        initialState={{
          pagination: {
            paginationModel: { page: 0, pageSize: 5 },
          },
        }}
        pageSizeOptions={[5, 10]}
        checkboxSelection
        onCellClick={(event) => {console.log(event)}} // field, formattedValue, isEditable
      />
    </React.Fragment>
  );
}
