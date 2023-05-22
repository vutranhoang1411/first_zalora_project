import axios from 'axios'

const SERVER_PATH = process.env.REACT_APP_BACKEND_URL
export const SupplierAPI = {
  createQueryString: (filters) => {
    const params = Object.entries(filters)
      .filter(([key, value]) => value !== '') // filter out empty values
      .map(
        ([key, value]) =>
          `${encodeURIComponent(key)}=${encodeURIComponent(value)}`
      )
    return params.join('&')
  },
  fetchSupplier: async function (
    page = 0,
    limit = 5,
    filters = { status: 'active' }
  ) {
    const filterstring = this.createQueryString(filters)
    const URL = `${SERVER_PATH}/supplier?page=${
      page + 1
    }&limit=${limit}&${filterstring}`
    console.log(URL)
    //const URL = `${process.env.REACT_APP_BACKEND_URL}/supplier`
    return await axios.get(URL)
  },
  createSupplier: async (data) => {
    const addressType = ['headquater', 'office', 'warehouse']
    let { HQAddress, WHAddress, OFFAddress, ...submitObject } = data
    const addressValue = [HQAddress, WHAddress, OFFAddress]
    submitObject['address'] = addressValue
      // eslint-disable-next-line eqeqeq
      .filter((value) => value !== undefined)
      .map((value, index) => {
        return {
          addr: value,
          type: addressType[index],
        }
      })
    const URL = `${SERVER_PATH}/supplier`
    return await axios.post(URL, submitObject)
  },
  editSupplier: async (data) => {
    let { HQAddress, WHAddress, OFFAddress, ...submitObject } = data
    const URL = `${SERVER_PATH}/supplier`
    return await axios.put(URL, submitObject)
  },
  deleteSupplier: async (id) => {
    const URL = `${SERVER_PATH}/supplier/${id}`
    return await axios.delete(URL)
  },
}
