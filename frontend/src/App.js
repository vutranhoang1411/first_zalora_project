import './App.css'
import { BrowserRouter, Route, Routes } from 'react-router-dom'
import { Homepage } from './pages/Homepage'
import { DashboardPage } from './pages/Dashboard'
import Layout from './layout'

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Layout />}>
          <Route index element={<DashboardPage />} />
          <Route path="suppliers" element={<Homepage />} />
        </Route>
      </Routes>
    </BrowserRouter>
  )
}

export default App
