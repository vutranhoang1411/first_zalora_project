import './App.scss'
import { BrowserRouter, Navigate, Route, Routes } from 'react-router-dom'
import { DashboardPage } from 'pages/Dashboard'
import { Address } from 'pages/Address'
import Layout from 'layout'
import SuppliersOfProduct from 'pages/ProductSupplier'
import Supplier from './components/supplier/supplier'

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Layout />}>
          <Route index element={<Navigate to="/product" />} />
          <Route path="product" element={<DashboardPage />} />
          <Route path="product/:productId" element={<SuppliersOfProduct />} />
          <Route path="suppliers" element={<Supplier />} />
          <Route path="/suppliers/:articleId" element={<Address />} />
        </Route>
      </Routes>
    </BrowserRouter>
  )
}

export default App
