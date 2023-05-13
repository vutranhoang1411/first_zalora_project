import * as React from 'react'
import ListItemButton from '@mui/material/ListItemButton'
import ListItemIcon from '@mui/material/ListItemIcon'
import ListItemText from '@mui/material/ListItemText'
import ListSubheader from '@mui/material/ListSubheader'
import DashboardIcon from '@mui/icons-material/Dashboard'
import ShoppingCartIcon from '@mui/icons-material/ShoppingCart'
// import PeopleIcon from '@mui/icons-material/People';
// import BarChartIcon from '@mui/icons-material/BarChart';
// import LayersIcon from '@mui/icons-material/Layers';
import AssignmentIcon from '@mui/icons-material/Assignment'
import { Divider, List } from '@mui/material'
import { Link } from 'react-router-dom'

export default function ListItemsSideBar() {
  return (
    <List component="nav">
      <React.Fragment>
        <ListItemButton component={Link} to={'/'}>
          <ListItemIcon>
            <DashboardIcon />
          </ListItemIcon>
          <ListItemText primary="Products" />
        </ListItemButton>

        <ListItemButton component={Link} to={'/suppliers'}>
          <ListItemIcon>
            <ShoppingCartIcon />
          </ListItemIcon>
          <ListItemText primary="Suppliers" />
        </ListItemButton>
      </React.Fragment>
      <Divider sx={{ my: 1 }} />
      <React.Fragment>
        <ListSubheader component="div" inset>
          Saved reports
        </ListSubheader>
        <ListItemButton>
          <ListItemIcon>
            <AssignmentIcon />
          </ListItemIcon>
          <ListItemText primary="Current month" />
        </ListItemButton>
        <ListItemButton>
          <ListItemIcon>
            <AssignmentIcon />
          </ListItemIcon>
          <ListItemText primary="Last quarter" />
        </ListItemButton>
        <ListItemButton>
          <ListItemIcon>
            <AssignmentIcon />
          </ListItemIcon>
          <ListItemText primary="Year-end sale" />
        </ListItemButton>
      </React.Fragment>
    </List>
  )
}
