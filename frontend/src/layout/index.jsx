import { AppBar, Button, Container, Divider, IconButton, Toolbar, Typography } from '@mui/material'
import React from 'react'
import Sidebar from './sidebar'
import MenuIcon from '@mui/icons-material/Menu';
import { Outlet } from 'react-router-dom';
import styles from "./styles.scss"

const Layout = () => {
  return (
    // <Container maxWidth="sm">
    //   <Sidebar />
    //   <AppBar style={{marginLeft: 300}}>
    //     <Toolbar>
    //       <IconButton
    //         size="large"
    //         edge="start"
    //         color="inherit"
    //         aria-label="menu"
    //         sx={{ mr: 2 }}
    //       >
    //         <MenuIcon />
    //       </IconButton>
    //       <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
    //         News
    //       </Typography>
    //       <Button color="inherit">Login</Button>
    //     </Toolbar>
    //   </AppBar>
    //   <div className={styles.header}>
    //     <Outlet />
    //   </div>
    // </Container>
    <div>
      <Outlet />
    </div>
  )
}

export default Layout