import './App.css'
import { BrowserRouter, Route, Routes } from 'react-router-dom'
import Layout from './layout'
import Homepage from './pages/homepage'
import Dashboard from './pages/dashboard'

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Layout />}>
          <Route index element={<Homepage />} />
          <Route path="dashboard" element={<Dashboard />} />
        </Route>
      </Routes>
    </BrowserRouter>
  )
}

export default App
