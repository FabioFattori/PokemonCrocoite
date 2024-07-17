import GeneralTable from './GeneralTable'
import { usePage } from '@inertiajs/react'
import { Divider } from '@mui/material';
import React from 'react';

function UserView() {
    /* User Variables */
    var team: any[] = (usePage().props.team as any[]) ?? [];
    var position: any[] = (usePage().props.position as any[]) ?? [];

    React.useEffect(() => {
    },[team]);
  return (
    <div>
        {/* <GeneralTable tableTitle="Team" dbObject={team} buttons={[]} /> */}
        <Divider /> 
        <h1>Posizione</h1>
        <p>{JSON.stringify(position)}</p>
    </div>
  )
}

export default UserView