import * as React from 'react'
import { DataGrid } from '@mui/x-data-grid'
import { Box, Button, Container, Paper } from '@mui/material'
import styles from './styles.module.scss'
import Title from 'components/title'
import Modal from '../supplierModal'
import { Link } from 'react-router-dom'
import CustomFilter from '../filter'
import FilterAltIcon from '@mui/icons-material/FilterAlt'
import { SupplierAPI } from '../../../services/supplier-api'
import { useRef, useState } from 'react'

export default function Supplier() {
  const columns = [
    { field: 'name', headerName: 'Name', width: 180, editable: false },
    { field: 'email', headerName: 'Email', width: 180, editable: false },
    {
      field: 'number',
      headerName: 'Contact Number',
      width: 200,
      editable: false,
    },
    {
      field: 'addresses',
      headerName: 'Address',
      width: 200,
      editable: false,
      renderCell: (params) => {
        const id = params?.row.id
        const name = params?.row.name
        return (
          <Link to={`/suppliers/address?id=${id}&name=${name}`}>
            <button>Go to Address</button>
          </Link>
        )
      },
    },
    { field: 'status', headerName: 'Status', width: 100, editable: false },
    {
      editable: true,
      field: 'action',
      headerName: 'Action',
      width: 200,
      renderCell: (params) => (
        <Box sx={{ margin: 2 }}>
          <Button
            sx={{ mr: 1 }}
            variant="contained"
            color="primary"
            onClick={() => handleRowEdit(params)}
          >
            Edit
          </Button>
          <Button
            variant="contained"
            color="error"
            onClick={() => handleRowDelete(params.row.id)}
          >
            Delete
          </Button>
        </Box>
      ),
    },
  ]
  //State initialize
  const [pageState, setPageState] = React.useState({
    isLoading: false,
    data: [],
    total: 0,
  })
  const [selectedRow, setSelectedRow] = React.useState(null)
  const [showFilter, setShowFilter] = React.useState(false)
  const [toggle, setToggle] = useState(false)

  const initialPageModelRef = useRef({
    page: 0,
    pageSize: 5,
  })

  const [paginationModel, setPaginationModel] = React.useState(
    initialPageModelRef.current
  )

  const initialFilterStateRef = useRef({
    name: '',
    email: '',
    number: '',
    status: 'active',
  })
  const [filter, setFilter] = useState(initialFilterStateRef.current)
  //setState logic function
  const handleToggleFilter = () => {
    setFilter(initialFilterStateRef.current)
    setShowFilter(!showFilter)
  }
  const handleRowEdit = (params) => {
    setSelectedRow(params.row)
  }
  const handleRowDelete = async (id) => {
    try {
      // make API call to delete row
      await SupplierAPI.deleteSupplier(id)
      setToggle(!toggle)
    } catch (error) {
      console.error(error)
      alert('An error occur')
    }
  }
  const handleAddRow = () => {
    setSelectedRow({})
  }
  const handleSave = async (editedrow) => {
    try {
      if (Object.keys(selectedRow).length !== 0) {
        await SupplierAPI.editSupplier(editedrow)
      } else {
        await SupplierAPI.createSupplier(editedrow)

        setPaginationModel((old) => ({
          ...old,
          page: Math.ceil(pageState.total / old.pageSize) - 1,
        }))
        console.log(paginationModel)
      }
      setFilter(initialFilterStateRef.current)
      setToggle(!toggle)
      setSelectedRow(null)
    } catch (e) {
      console.error(e)
      alert('An error occur')
    }
  }
  const setNewFilter = (data) => {
    if (!data) {
      return setFilter(initialFilterStateRef.current)
    }
    setFilter({ ...filter, ...data })
  }
  const submitFiter = () => {
    setToggle(!toggle)
  }

  React.useEffect(() => {
    const fetchData = async () => {
      try {
        setPageState((old) => ({
          ...old,
          isLoading: true,
        }))
        const result = await SupplierAPI.fetchSupplier(
          paginationModel.page,
          paginationModel.pageSize,
          filter
        )
        setPageState((old) => ({
          ...old,
          isLoading: false,
          data: result.data.items,
          total: result.data.total_items,
        }))
      } catch (e) {
        setPageState((old) => ({
          ...old,
          isLoading: false,
          data: [],
          total: 0,
        }))
        console.log(e)
        alert('Can received the Supplier List')
      }
    }
    fetchData()
  }, [paginationModel, toggle])

  return (
    <Container maxWidth="lg" sx={{ mt: 4, mb: 4, mr: 2, ml: 2 }}>
      <Paper sx={{ p: 2, display: 'flex', flexDirection: 'column' }}>
        <div className={styles.title}>
          <Title>Supplier</Title>
          <div>
            <Button onClick={handleToggleFilter}>
              <FilterAltIcon />{' '}
            </Button>
            <Button onClick={handleAddRow}>+</Button>
          </div>
        </div>
        {showFilter && (
          <CustomFilter
            filter={filter}
            setFilter={setNewFilter}
            submitFilter={submitFiter}
          />
        )}
        <DataGrid
          rows={pageState.data}
          rowCount={pageState.total}
          loading={pageState.isLoading}
          pageSizeOptions={[5]}
          paginationModel={paginationModel}
          paginationMode="server"
          onPaginationModelChange={setPaginationModel}
          columns={columns}
          rowSelection={false}
        />

        <Modal
          selectedRow={selectedRow}
          handleSave={handleSave}
          setSelectedRow={setSelectedRow}
        ></Modal>
      </Paper>
    </Container>
  )
}
