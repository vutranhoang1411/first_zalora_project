import './App.css'
import { BrowserRouter, Route, Routes } from 'react-router-dom'
import { DashboardPage } from 'pages/Dashboard'
import { Homepage } from 'pages/Homepage'
import Layout from 'layout'

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
