import './App.scss'
import { BrowserRouter, Route, Routes } from 'react-router-dom'
import { DashboardPage } from 'pages/Dashboard'
import { Homepage } from 'pages/Homepage'
import Layout from 'layout'
import SuppliersOfProduct from 'pages/ProductSupplier'

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Layout />}>
          <Route index element={<DashboardPage />} />
          <Route path="suppliers" element={<Homepage />} />
          <Route path="product" element={<DashboardPage />}>
            <Route index element={<DashboardPage />} />
            <Route path=":productId" element={<SuppliersOfProduct />} />
          </Route>
        </Route>
      </Routes>
    </BrowserRouter>
  )
}

export default App
