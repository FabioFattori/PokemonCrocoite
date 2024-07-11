import { usePage } from '@inertiajs/react';
import React from 'react'
import { buttons, setTableToUse } from '../../utils/buttons';
import SideBar from '../../Components/SideBar';
import userMode from '../../Components/userMode';
import GeneralTable from '../../Components/GeneralTable';

function Posizioni() {
    var pos = (usePage().props.positions as any[]) ?? null;
    setTableToUse("positions");

    React.useEffect(() => {
        console.log(pos);
    },[]);

    return (
        <>
            <SideBar title={"Posizioni legate agli utenti, npc, palestre e zone"} mode={userMode.admin}/>
            <GeneralTable tableTitle='Posizioni' dbObject={pos} buttons={buttons} />
        </>
    )
}

export default Posizioni