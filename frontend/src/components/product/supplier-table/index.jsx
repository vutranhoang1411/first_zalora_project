import * as React from 'react'
import { DataGrid } from '@mui/x-data-grid'
import { Button, Container, Paper } from '@mui/material'
import styles from './styles.module.scss'
import Title from 'components/title'
import { useParams } from 'react-router-dom'

const dummy = [
  {
    id: 101,
    name: 'ZLWO Supp',
    stock: 203,
  },
  {
    id: 102,
    name: 'POpE',
    stock: 203,
  },
  {
    id: 111,
    name: 'Xingtuup',
    stock: 203,
  },
  {
    id: 132,
    name: 'Shopeep',
    stock: 203,
  },
  {
    id: 201,
    name: 'Express Supp',
    stock: 100,
  },
]

const SuppliersDetail = () => {
  const { productId } = useParams()
  const columns = [
    {
      field: 'name',
      label: 'Supplier Name',
    },
    {
      field: 'stock',
      label: 'Supplier Stock',
    },
  ]
  return (
    <Container maxWidth="lg" sx={{ mt: 4, mb: 4 }}>
      <Paper sx={{ p: 2, display: 'flex', flexDirection: 'column' }}>
        <div className={styles.title}>
          <Title>Product {productId}</Title>
          <Button> +</Button>
        </div>
        <DataGrid
          rows={dummy}
          columns={columns}
          initialState={{
            pagination: {
              paginationModel: { page: 0, pageSize: 10 },
            },
          }}
          pageSizeOptions={[10, 50]}
          checkboxSelection
          onCellClick={(event) => {
            // console.log(event) // field, formattedValue, isEditable
          }}
        />
      </Paper>
    </Container>
  )
}

export default SuppliersDetail
