import { useState, useEffect } from 'react'
import {
  Button,
  Modal,
  Typography,
  TextField,
  Box,
  MenuItem,
} from '@mui/material'

let uniqueid = 15
const statusEnum = [
  {
    value: 'active',
    label: 'active',
  },
  {
    value: 'inactive',
    label: 'inactive',
  },
]
function RowModal({ selectedRow, handleSave, setSelectedRow }) {
  const [open, setOpen] = useState(Boolean(selectedRow))
  const [data, setData] = useState({ ...selectedRow })
  console.log(data)
  useEffect(() => {
    setOpen(Boolean(selectedRow))
    setData({ ...selectedRow })
  }, [selectedRow])
  const handleInputChange = (e) => {
    const { name, value } = e.target
    setData((prevData) => ({
      ...prevData,
      [name]: value,
    }))
  }
  const handleClose = (event, reason) => {
    if (reason === 'backdropClick') return
    if (reason === 'escapeKeyDown') {
      setSelectedRow(null)
      return
    }
    handleSubmit()
  }
  const handleCancel = () => {
    setSelectedRow(null)
  }
  const handleSubmit = async () => {
    try {
      //add active status if not exits (in created case).
      if (!data.status) {
        data.status = 'active'
      }

      //cal API

      //close the modal and save the recent change to the UI
      if (!data.id) {
        data.id = uniqueid
        uniqueid += 1
      }
      handleSave(data)
    } catch (e) {
      console.log(e)
      alert('An error occur')
    }
  }

  let isNewRow = selectedRow && Object.keys(selectedRow).length !== 0

  return (
    <Modal open={open} onClose={handleClose}>
      <Box
        sx={{
          position: 'absolute',
          top: '50%',
          left: '50%',
          transform: 'translate(-50%, -50%)',
          width: 400,
          bgcolor: 'background.paper',
          boxShadow: 24,
          p: 4,
        }}
      >
        <Typography variant="h6">
          {isNewRow ? `Edit ${selectedRow.name}` : 'Create New Row'}
        </Typography>
        <TextField
          label="Name"
          name="name"
          value={data.name ? data.name : ' '}
          onChange={handleInputChange}
          fullWidth
        />
        <TextField
          label="Email"
          type="email"
          name="email"
          value={data.email ? data.email : ' '}
          onChange={handleInputChange}
          fullWidth
        />
        <TextField
          label="Contact Number"
          type="contact"
          name="number"
          value={data.number ? data.number : ' '}
          onChange={handleInputChange}
          fullWidth
        />
        <TextField
          select
          label="Status"
          value={data.status ? data.status : 'active'}
          name="status"
          onChange={handleInputChange}
        >
          {statusEnum.map((option) => (
            <MenuItem key={option.value} value={option.value}>
              {option.label}
            </MenuItem>
          ))}
        </TextField>

        {isNewRow ? (
          ''
        ) : (
          <div>
            <TextField
              label=" HQ Address"
              name="HQAddress"
              value={data.HQAddress ? data.HQAddress : ''}
              onChange={handleInputChange}
              fullWidth
            />
            <TextField
              label="WareHouse Address"
              name="WHAddress"
              value={data.WHAddress ? data.WHAddress : ''}
              onChange={handleInputChange}
              fullWidth
            />
            <TextField
              label="OFFice Address"
              name="OFFAddress"
              value={data.OFFAddress ? data.OFFAddress : ''}
              onChange={handleInputChange}
              fullWidth
            />
          </div>
        )}
        <Box sx={{ mt: 2 }}>
          <Button
            variant="contained"
            color="info"
            onClick={handleSubmit}
            sx={{ mr: 1 }}
          >
            Save
          </Button>
          <Button variant="contained" color="primary" onClick={handleCancel}>
            Cancel
          </Button>
        </Box>
      </Box>
    </Modal>
  )
}

export default RowModal
