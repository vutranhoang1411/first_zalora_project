import { Drawer } from '@mui/material'
import React from 'react'

const Sidebar = (props) => {
  return (
    <Drawer open={true} variant='permanent'>
      {props.children}
    </Drawer>
  )
}

export default Sidebar