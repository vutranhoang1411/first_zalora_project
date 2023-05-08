import axios from 'axios'
export const api = {
  fetchUsers: async () => {
    const URL = 'https://jsonplaceholder.typicode.com/users'
    return await axios
      .get(URL)
      .then((res) => res)
      .catch((err) => err)
  },
}
