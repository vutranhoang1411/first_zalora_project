import { DataGrid } from '@mui/x-data-grid'
import { Button, Container, Paper } from '@mui/material'
import styles from './styles.module.scss'
import Title from 'components/title'
import { ProductDataList } from 'services/dummy-data'
import { useEffect, useState } from 'react'
import { ProductAPI } from 'services/api'
import ProductTableHead from '../table-head'
import ModalEditProductTable from '../edit-modal'
import { Link as RouterLink } from 'react-router-dom'

// Generate Order Data
// GridColDef[]
const dummy = ProductDataList.concat(ProductDataList)
  .concat(ProductDataList)
  .map((value, idx) => {
    const { id, ...other } = value
    return {
      id: idx + 10,
      ...other,
    }
  })
export default function ProductTable() {
  const [loading, setLoading] = useState(false)
  const [productList, setProductList] = useState(dummy)
  const [rowSelectionIndex, setRowSelectionIndex] = useState([])
  const [openModalInfo, setOpenModalInfo] = useState(false)
  const [openEditModal, setOpenEditModal] = useState(false)
  const [selectedRow, setSelectedRow] = useState(null)
  const handleRowSelection = (newSelectedRow) => {
    setRowSelectionIndex(newSelectedRow)
  }
  const deleteRowHandler = () => {
    ProductAPI.deleteProduct(rowSelectionIndex[0])
    console.log(rowSelectionIndex)
    const newList = productList.filter((value) => {
      for (let id of rowSelectionIndex) {
        if (value.id === id) {
          return false
        }
      }
      return true
    })
    setProductList(newList)
    setRowSelectionIndex([])
    // setLoading(true)
    // call API delete multiple products
    // setLoading(false)
  }
  const showMoreHandler = (row) => {
    setSelectedRow(row)
    setOpenModalInfo(true)
  }

  const editModalHandler = (product) => {
    setSelectedRow(product)
    setOpenEditModal(true)
  }

  const setEditProduct = (product) => {
    if (product == null) {
      return
    }
    for (let current of productList) {
      if (product.id === current.id) {
        current = product
        break
      }
    }
    setProductList(productList)
  }

  /* First reload page and reload whenever productList change, uncomment it
  when API is called successfully */
  /* useEffect(() => {
    ProductAPI.fetchAllProducts()
      .then((res) => {
        setProductList(dummy.slice(1, 3))
      })
      .catch((e) => {
        // >>> client side logger
        console.log(e)
        setProductList(dummy)
      })
  }, [productList]) */

  const columns = [
    { field: 'name', headerName: 'Name', width: 300 },
    { field: 'brand', headerName: 'Brand', width: 150 },
    { field: 'sku', headerName: 'SKU', width: 120 },
    {
      field: 'size',
      headerName: 'Size',
      width: 100,
    },
    { field: 'color', headerName: 'Color', width: 100 },
    { field: 'stock', headerName: 'Stock', width: 100 },
    {
      field: '',
      headerName: 'Actions',
      width: 250,
      hideSortIcons: true,
      renderCell: (params) => {
        const { row: product } = params
        return (
          <div>
            <Button
              variant="contained"
              size="small"
              style={{ marginRight: 10 }}
              // onClick={() => showMoreHandler(product)}
              component={RouterLink}
              to={`product/${product.id}`}
            >
              All Suppliers
            </Button>
            <Button
              variant="outlined"
              size="small"
              onClick={() => editModalHandler(product)}
            >
              Edit
            </Button>
          </div>
        )
      },
    },
  ]
  return (
    <Container maxWidth="lg" sx={{ mt: 4, mb: 4 }}>
      <Paper sx={{ p: 2, display: 'flex', flexDirection: 'column' }}>
        <ProductTableHead
          rowSelected={rowSelectionIndex.length}
          deleteRowHandler={deleteRowHandler}
          sx={{ ml: 2 }}
        />
        {selectedRow && (
          <ModalEditProductTable
            productInfo={selectedRow}
            // setProductInfo={(info) => setSelectedRow(info)}
            open={openEditModal}
            setClose={() => setOpenEditModal(false)}
            setEditProduct={() => setEditProduct()}
          />
        )}

        <DataGrid
          rows={productList}
          columns={columns}
          sx={{ ml: 2 }}
          initialState={{
            pagination: {
              paginationModel: { page: 0, pageSize: 10 },
            },
          }}
          pageSizeOptions={[10, 50]}
          // checkboxSelection
          loading={loading}
          onRowSelectionModelChange={handleRowSelection}
          rowSelectionModel={rowSelectionIndex}
          onSortModelChange={(first) => {
            // array [{field: '', sort: 'asc' | 'desc'}]
            // console.log(first)
          }}
        />
      </Paper>
    </Container>
  )
}
