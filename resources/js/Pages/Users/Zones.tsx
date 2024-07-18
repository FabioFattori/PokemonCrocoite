import { usePage } from '@inertiajs/react'
import React from 'react'
import SideBar from '../../Components/SideBar'
import userMode from '../../Components/userMode'
import ZoneDrawer from '../../Components/UserComponents/ZoneDrawer'

function Zones() {

    

  return (
    <>
        <SideBar title={"Mappa"} mode={userMode.user} />
        <ZoneDrawer />
    </>
  )
}

export default Zones