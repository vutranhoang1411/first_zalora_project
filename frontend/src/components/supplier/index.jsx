import * as React from 'react'
import { DataGrid, GridRowEditStopReasons } from '@mui/x-data-grid'
import { Button, Container, Paper } from '@mui/material'
import styles from './styles.module.scss'
import Title from 'components/title'
import axios from 'axios'
import { v4 as uuidv4 } from 'uuid'
// Generate Order Data
// GridColDef[]

export default function Supplier() {
  const columns = [
    { field: 'name', headerName: 'Name', width: 200, editable: true },
    { field: 'email', headerName: 'Email', width: 200, editable: true },
    {
      field: 'contact',
      headerName: 'Contact Number',
      width: 200,
      editable: true,
    },
    {
      field: 'addresses',
      headerName: 'Address',
      width: 200,
      editable: true,
      renderCell: (params) => {
        const addresses = params?.value
        return (
          <div>
            {addresses.map((addr, index) => (
              <div key={index}>
                {addr.street}, {addr.city}, {addr.country}
              </div>
            ))}
          </div>
        )
      },
    },
    { field: 'status', headerName: 'Status', width: 100, editable: true },
    {
      field: 'action',
      headerName: 'Action',
      width: 120,
      renderCell: () => <button>Delete</button>,
    },
  ]

  const [data, setData] = React.useState([])

  const handleRowDelete = async (params) => {
    const prevData = [...data] // make a copy of previous state
    const { id } = params

    try {
      // make API call to delete row
      //await deleteRow(id)

      const newData = prevData.filter((row) => row.id !== id)
      setData(newData)
    } catch (error) {
      console.error(error)
      // revert back to previous state in case of error
      setData(prevData)
    }
  }

  React.useEffect(() => {
    const fetchData = async () => {
      //Fake json//Get data in server
      const result = await axios('/data.json')
      setData(result.data.suppliers)
    }
    fetchData()
  }, [])
  const handleRowEditStop = (params, event) => {
    if (params.reason === GridRowEditStopReasons.escapeKeyDown) {
      return
    }

    const { id, field, value } = params
    console.log(params)
    const updatedRow = { ...params.row, [field]: value }

    try {
      // Make API call to update the row data
      //const response = await axios.put(`/api/rows/${id}`, updatedRow);

      setData((prevData) =>
        prevData.map((row) => (row.id === id ? updatedRow : row))
      )
    } catch (error) {
      //sparams.api.updateRowsData({ update: [params.row] })
      console.error(error)
    }
  }

  const newId = uuidv4()
  const handleAddRow = () => {
    const newRow = {
      id: newId,
      name: 'Name',
      email: 'Email',
      addresses: [],
      age: 0,
      status: 0,
    }
    setData([...data, newRow])
  }

  return (
    <Container maxWidth="lg" sx={{ mt: 4, mb: 4 }}>
      <Paper sx={{ p: 2, display: 'flex', flexDirection: 'column' }}>
        <div className={styles.title}>
          <Title>Supplier</Title>
          <Button onClick={handleAddRow}> +</Button>
        </div>
        <DataGrid
          editMode="row"
          rows={data}
          columns={columns}
          onRowEditStop={handleRowEditStop}
          initialState={{
            pagination: {
              paginationModel: { page: 0, pageSize: 5 },
            },
          }}
          pageSizeOptions={[10, 50]}
          checkboxSelection
          onCellClick={(params) => {
            if (params.field === 'action') {
              handleRowDelete(params.row)
            }
          }}
        />
      </Paper>
    </Container>
  )
}
