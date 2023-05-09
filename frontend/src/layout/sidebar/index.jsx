import { Drawer, List,  ListItemButton, ListItemIcon, ListItemText, ListSubheader } from '@mui/material'
import SendIcon from '@mui/icons-material/Send';
import DraftsIcon from '@mui/icons-material/Drafts';
import React from 'react'

const Sidebar = (props) => {
  return (
    <Drawer open={true} variant='persistent'>
      <List
      subheader={
        <ListSubheader >
          Menu
        </ListSubheader>
      }>
      <ListItemButton>
        <ListItemIcon>
          <SendIcon />
        </ListItemIcon>
        <ListItemText primary="Sent mail" />
      </ListItemButton>
      <ListItemButton>
        <ListItemIcon>
          <DraftsIcon />
        </ListItemIcon>
        <ListItemText primary="Drafts" />
        </ListItemButton>
      </List>
    </Drawer>
  )
}

export default Sidebar