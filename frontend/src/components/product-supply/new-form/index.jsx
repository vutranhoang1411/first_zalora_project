import React, { useState } from 'react'
import {
  Box,
  Button,
  FormControl,
  InputLabel,
  MenuItem,
  Modal,
  OutlinedInput,
  Select,
  TextField,
  Typography,
} from '@mui/material'
import {
  ProductApi,
  ProductSuppyApi,
  useCreateNewSupplierOfProductMutation,
  useGetAllProductsQuery,
  useGetAllSuppliersQuery,
} from 'services/createApi'
import styles from './styles.module.scss'
import { store } from 'store/store'

const labelField = [
  {
    field: 'suppliername',
    label: 'Supplier Name',
  },
  {
    field: 'stock',
    label: 'Supplier Stock',
  },
]

const ModalNewSupplierForProductModal = (props) => {
  const { open, setClose, productId, refetchAllSuppliers } = props
  const [newSupplier, setNewSupplier] = useState({})

  const [createNewSupplier, { loading, data, error }] =
    useCreateNewSupplierOfProductMutation()
  const {
    data: supplierData,
    loading: supplierLoading,
    error: supplierError,
  } = useGetAllSuppliersQuery()
  const handleClose = () => {
    setClose()
  }

  const handleFieldChangeClick = (value) => {
    console.log(supplierData[value])
    const { id, name } = supplierData[value]
    const newSup = { id, name }
    setNewSupplier(newSup)
  }

  const onSubmitChange = () => {
    console.log('>> new product ', newSupplier, productId)
    createNewSupplier({
      productId,
      supplierId: newSupplier.id,
      supplierStock: newSupplier.stock,
    })
      .unwrap()
      .then((res) => {
        // store.dispatch(ProductApi.endpoints.getAllProducts.)
        refetchAllSuppliers()
        return res
      })
      .catch((err) => {
        console.log(err)
      })
    handleClose()
  }
  const onInputNewFieldValue = (value, field) => {
    newSupplier[field] = value
    console.log(newSupplier)
    setNewSupplier(newSupplier)
  }
  return (
    <Modal
      open={open}
      onClose={handleClose}
      aria-labelledby="modal-modal-title"
      aria-describedby="modal-modal-description"
    >
      <Box className={styles.modal}>
        {/* sx={style} */}
        <Typography
          id="modal-modal-title"
          variant="h4"
          // component="h2"
          sx={{ m: 1, mb: 2 }}
        >
          Create New Product
        </Typography>
        <Box
          component="form"
          sx={{
            '& > :not(style)': { m: 1 },
          }}
          noValidate
          autoComplete="off"
        >
          <Select
            variant="outlined"
            label="Supplier ID"
            value={newSupplier.name ? newSupplier.name : 'Unknown'}
            // onChange={(e) => handleFieldChangeClick(e.target.value, 'id')}
          >
            {supplierData &&
              supplierData.map((option, idx) => {
                return (
                  <MenuItem
                    key={option.id}
                    value={option.name}
                    onClick={() => handleFieldChangeClick(idx, 'id')}
                  >
                    {option.name}
                  </MenuItem>
                )
              })}
          </Select>

          <FormControl key={'stock'} fullWidth size="small">
            <InputLabel htmlFor="component-outlined">{'stock'}</InputLabel>
            <OutlinedInput
              id="component-outlined"
              label={'stock'}
              onChange={(event) =>
                onInputNewFieldValue(event.target.value, 'stock')
              }
            />
          </FormControl>
        </Box>
        <Box className={styles.submit} sx={{ m: 1, mt: 2, gap: 1 }}>
          <Button
            type="submit"
            variant="contained"
            sx={{ mr: 1 }}
            onClick={() => onSubmitChange()}
          >
            Submit
          </Button>
          <Button
            type="submit"
            variant="outlined"
            onClick={() => handleClose()}
          >
            Cancel
          </Button>
        </Box>
      </Box>
    </Modal>
  )
}

export default ModalNewSupplierForProductModal
