import {
  Box,
  Button,
  FormControl,
  InputLabel,
  MenuItem,
  Modal,
  OutlinedInput,
  TextField,
  Typography,
} from '@mui/material'
import React, { useState } from 'react'
import styles from './styles.module.scss'
import { ParseObjectToValueLabel } from 'components/util/func'
import { ProductColor, ProductSize } from 'components/util/constant'
import { ProductAPI } from 'services/api'

const brandList = [
  {
    value: 'HM',
    label: 'HM store',
  },
  {
    value: 'Uniqlo',
    label: 'Uniqlo Asia',
  },
  {
    value: 'Nike',
    label: 'Nike Basketball',
  },
]

const sizeList = ParseObjectToValueLabel(ProductSize)
const colorList = ParseObjectToValueLabel(ProductColor)

const ModalEditProductTable = (props) => {
  const { productInfo = null, open = false, setClose, setEditProduct } = props
  const [productNewInfo, setProductNewInfo] = useState(productInfo)
  const [newProductName, setNewProductName] = useState('')
  const [newProductSku, setNewProductSku] = useState('')
  // const nameInputRef = useRef()
  const handleClose = () => {
    setClose()
  }
  const onSubmitChange = () => {
    const newProduct = {
      ...productNewInfo,
      name: newProductName.length !== 0 ? newProductName : productInfo.name,
      sku: newProductSku.length !== 0 ? newProductSku : productInfo.sku,
    }
    ProductAPI.editProduct(newProduct)
    setEditProduct(newProduct)
    console.log('Submit', newProduct)
    setClose()
  }

  const inputNewSku = (val) => {
    setNewProductSku(val)
  }

  const handleFieldChangeClick = (sizeValueLabel, field) => {
    for (let productField in productInfo) {
      if (field === productField) {
        productInfo[field] = sizeValueLabel.value
      }
    }
    setProductNewInfo(productInfo)
  }

  const onInputNewName = (value) => {
    setNewProductName(value)
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
          Editing Product
        </Typography>
        <Box
          component="form"
          sx={{
            '& > :not(style)': { m: 1 },
          }}
          noValidate
          autoComplete="off"
        >
          <FormControl fullWidth>
            <InputLabel htmlFor="component-outlined">Name</InputLabel>
            <OutlinedInput
              id="component-outlined"
              defaultValue={productInfo?.name}
              label="Name"
              // error={}
              // ref={nameInputRef}
              onChange={(event) => onInputNewName(event.target.value)}
            />
          </FormControl>
          <TextField
            // helperText="Product Name"
            defaultValue="HM"
            variant="outlined"
            // fullWidth
            select
            label="Brand"
          >
            {brandList.map((option) => (
              <MenuItem
                key={option.value}
                value={option.value}
                selected={option?.label === productInfo?.brand}
                onClick={() => handleFieldChangeClick(option, 'brand')}
              >
                {option.label}
              </MenuItem>
            ))}
          </TextField>
          <FormControl>
            <InputLabel htmlFor="component-outlined">SKU</InputLabel>
            <OutlinedInput
              id="component-outlined"
              defaultValue={productInfo?.sku}
              label="SKU"
              onChange={(e) => inputNewSku(e.target.value)}
            />
          </FormControl>
          <TextField
            select
            variant="outlined"
            label="Color"
            defaultValue={productInfo?.color.toUpperCase()}
          >
            {colorList &&
              colorList.map((option) => (
                <MenuItem
                  key={option.value}
                  value={option.value}
                  selected={option.value === productInfo?.color}
                  onClick={() => handleFieldChangeClick(option, 'color')}
                >
                  {option.label}
                </MenuItem>
              ))}
          </TextField>
          <FormControl>
            <TextField
              select
              variant="outlined"
              label="Size"
              defaultValue={productInfo?.size}
            >
              {sizeList &&
                sizeList.map((option) => (
                  <MenuItem
                    key={option.value}
                    value={option.value}
                    selected={option?.label === productInfo?.size}
                    onClick={() => handleFieldChangeClick(option, 'size')}
                  >
                    {option.label}
                  </MenuItem>
                ))}
            </TextField>
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

export default ModalEditProductTable
