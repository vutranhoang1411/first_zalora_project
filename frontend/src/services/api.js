import axios from 'axios'
export const ProductAPI = {
  fetchAllProducts: async () => {
    const URL = `${process.env.REACT_APP_BACKEND_URL}/product`
    try {
      await axios
        .get(URL)
        .then((res) => res)
        .catch((err) => err)
    } catch (e) {
      // >>> client log error
      console.log(e)
    }
  },

  editProduct: async (body) => {
    const URL = `${process.env.REACT_APP_BACKEND_URL}/product/${body?.id}`
    try {
      await axios
        .post(URL, body)
        .then((res) => res)
        .catch((err) => err)
    } catch (e) {
      // >>> client log error
      console.log(e)
    }
  },
  deleteProduct: async (productId) => {
    const URL = `${process.env.REACT_APP_BACKEND_URL}/product/${productId}`
    try {
      await axios
        .delete(URL)
        .then((res) => res)
        .catch((err) => err)
    } catch (e) {
      // >>> client log error
      console.log(e)
    }
  },
  createProduct: async (body) => {
    const URL = `${process.env.REACT_APP_BACKEND_URL}/product`
    try {
      await axios
        .put(URL, body)
        .then((res) => res)
        .catch((err) => err)
    } catch (e) {
      // >>> client log error
      console.log(e)
    }
  },
  getSuppliers: async (productId) => {
    const URL = `${process.env.REACT_APP_BACKEND_URL}/supplier?productId=${productId}`
    try {
      await axios
        .get(URL)
        .then((res) => res)
        .catch((err) => err)
    } catch (e) {
      // >>> client log error
      console.log(e)
    }
  },
}
