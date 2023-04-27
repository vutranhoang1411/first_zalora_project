import './App.css'
import { BrowserRouter, Route, Routes } from 'react-router-dom'
import Layout from './layout'
import { Homepage } from './pages/Homepage'
import { DashboardPage } from './pages/Dashboard'

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Layout />}>
          <Route index element={<DashboardPage />} />
          <Route path="another" element={<Homepage />} />
        </Route>
      </Routes>
    </BrowserRouter>
  )
}

export default App
