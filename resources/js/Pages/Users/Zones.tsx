import { usePage } from '@inertiajs/react'
import React from 'react'
import SideBar from '../../Components/SideBar'
import userMode from '../../Components/userMode'

function Zones() {
    let zones = usePage().props.zones as any[]

    

  return (
    <>
        <SideBar title={"Mappa"} mode={userMode.user} />
        <h1 style={{fontSize:"100px"}}>PORCODIO</h1>
    </>
  )
}

export default Zones