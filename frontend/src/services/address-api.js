import axios from 'axios'

const SERVER_PATH = `http://localhost:80/api`

export const AddressAPI = {
  fetchSupplierAddress: async (id) => {
    const URL = `${SERVER_PATH}/address?supplierid=${id}`
    return await axios.get(URL)
  },
  deleteAddress: async (id) => {
    const URL = `${SERVER_PATH}/address/${id}`
    return await axios.delete(URL)
  },
  editAddress: async (data) => {
    const URL = `${SERVER_PATH}/address`
    return await axios.put(URL, data)
  },
  addAddress: async (data) => {
    const URL = `${SERVER_PATH}/address`
    return await axios.put(URL, data)
  },
}
