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
import React, { useEffect, useState } from 'react'
import styles from './styles.module.scss'
import { ParseObjectToValueLabel } from 'util/func'
import { ProductColor, ProductSize } from 'util/constant'
import { useEditProductMutation } from 'services/createApi'

const sizeList = ParseObjectToValueLabel(ProductSize)
const colorList = ParseObjectToValueLabel(ProductColor)

const ModalEditProductTable = (props) => {
  const {
    productInfo = null,
    open = false,
    setClose,
    refetchAllProducts,
  } = props
  const [productNewInfo, setProductNewInfo] = useState({})
  const [editProduct, { isLoading, data, error }] = useEditProductMutation()

  // const nameInputRef = useRef()
  const handleClose = () => {
    setClose()
  }
  const onSubmitChange = () => {
    const submitProduct = {
      ...productInfo,
      ...productNewInfo,
    }
    console.log(submitProduct)
    editProduct(submitProduct)
    if (isLoading) {
      console.log('is loading... to edit product')
    } else {
      console.log('load done... to edit product')
      setClose()
    }
  }

  useEffect(() => {
    if (data) {
      console.log('data after edit product', data)
      refetchAllProducts()
    }
  }, [data])

  const handleFieldChangeClick = (value, field) => {
    productNewInfo[field] = value
    console.log(productNewInfo)
    setProductNewInfo(productNewInfo)
  }

  const onInputNewValueField = (value, field) => {
    productNewInfo[field] = value
    console.log(productNewInfo)
    setProductNewInfo(productNewInfo)
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
              onChange={(event) =>
                onInputNewValueField(event.target.value, 'name')
              }
            />
          </FormControl>
          <FormControl fullWidth>
            <InputLabel htmlFor="component-outlined">Brand</InputLabel>
            <OutlinedInput
              id="component-outlined"
              defaultValue={productInfo?.brand}
              label="Brand"
              onChange={(event) =>
                onInputNewValueField(event.target.value, 'brand')
              }
            />
          </FormControl>
          <Select
            variant="outlined"
            label="Color"
            value={
              productNewInfo?.color ? productNewInfo?.color : productInfo.color
            }
            onChange={(e) => handleFieldChangeClick(e.target.value, 'color')}
          >
            {colorList &&
              colorList.map((option) => (
                <MenuItem key={option.value} value={option.value}>
                  {option.label}
                </MenuItem>
              ))}
          </Select>
          <Select
            variant="outlined"
            label="Size"
            value={
              productNewInfo?.size ? productNewInfo?.size : productInfo.size
            }
            onChange={(event) =>
              handleFieldChangeClick(event.target.value, 'size')
            }
          >
            {sizeList &&
              sizeList.map((option) => (
                <MenuItem key={option.value} value={option.value}>
                  {option.label}
                </MenuItem>
              ))}
          </Select>
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
