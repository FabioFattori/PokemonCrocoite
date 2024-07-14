import React from 'react'
import { buttons, setTableToUse } from '../../utils/buttons';
import userMode from '../../Components/userMode';
import SideBar from '../../Components/SideBar';
import GeneralTable from '../../Components/GeneralTable';
import { usePage } from '@inertiajs/react';

function Palestre() {
    var gyms = (usePage().props.gyms as any[]) ?? null;
    setTableToUse("gyms");

    React.useEffect(() => {
        console.log(gyms);
    },[]);

    return (
        <>
        <SideBar title={"Palestre Pokemon"} mode={userMode.admin}/>
        <GeneralTable tableTitle='Palestre' dbObject={gyms} buttons={buttons} />
        </>
    )
}

export default Palestre