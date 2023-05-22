import { useState, useEffect } from 'react'
import {
  Button,
  Modal,
  Typography,
  TextField,
  Box,
  MenuItem,
} from '@mui/material'

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
  const [error, setError] = useState({ error: false, helperText: '' })

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
      setError({ error: false, helperText: '' })
      return
    }
    handleSubmit()
  }
  const handleCancel = () => {
    setSelectedRow(null)
    setError({ error: false, helperText: '' })
  }
  const handleSubmit = async () => {
    try {
      if (!data.name || !data.email || !data.number) {
        setError({ error: true, helperText: "Data shouldn't be null" })
        return
      }

      //add active status if not exits (in created case).
      if (!data.status) {
        data.status = 'active'
      }
      handleSave(data)
      setError({ error: false, helperText: '' })
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
          error={error.error}
          helperText={error.helperText}
        />
        <TextField
          label="Email"
          type="email"
          name="email"
          value={data.email ? data.email : ' '}
          onChange={handleInputChange}
          fullWidth
          error={error.error}
          helperText={error.helperText}
        />
        <TextField
          label="Contact Number"
          type="contact"
          name="number"
          value={data.number ? data.number : ' '}
          onChange={handleInputChange}
          fullWidth
          error={error.error}
          helperText={error.helperText}
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
              label="Office Address"
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
