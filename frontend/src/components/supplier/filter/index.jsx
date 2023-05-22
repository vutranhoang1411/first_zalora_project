import { Button, TextField, Box, MenuItem } from '@mui/material'
import styles from './styles.module.css'

export default function CustomFilter({ filter, setFilter, submitFilter }) {
  const handleFilterChange = (event) => {
    const { name, value } = event.target
    setFilter({
      [name]: value,
    })
  }
  const resetState = () => {
    setFilter(0)
  }
  return (
    <div className="custom-filter">
      <Box display="flex" alignItems="center" sx={{ mb: 2 }}>
        <TextField
          className={styles['text-field']}
          label="Name"
          name="name"
          value={filter.name}
          onChange={handleFilterChange}
          sx={{ mr: 2 }}
        />
        <TextField
          className={styles['text-field']}
          label="Email"
          name="email"
          value={filter.email}
          onChange={handleFilterChange}
          sx={{ mr: 2 }}
        />

        <Button
          className={styles['custom-filter-button']}
          color="primary"
          // variant="contained"
          onClick={submitFilter}
          sx={{ mr: 2 }}
        >
          Apply
        </Button>
        <Button
          className={styles['custom-filter-button']}
          // color="secondary"
          // variant="outlined"
          onClick={resetState}
        >
          Reset to default
        </Button>
      </Box>
    </div>
  )
}
