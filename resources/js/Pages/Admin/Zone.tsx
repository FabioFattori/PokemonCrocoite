import { usePage } from '@inertiajs/react';
import React from 'react'
import { buttons, setTableToUse } from '../../utils/buttons';
import SideBar from '../../Components/SideBar';
import userMode from '../../Components/userMode';
import GeneralTable from '../../Components/GeneralTable';

function Zone() {
    var zones = (usePage().props.zones as any[]) ?? null;
    setTableToUse("zones");

    React.useEffect(() => {
        console.log(zones);
    },[]);

    return (
        <>
        <SideBar title={"Zone"} mode={userMode.admin}/>
        <GeneralTable tableTitle='Zone' dbObject={zones} buttons={buttons} />
        </>
    )
}

export default Zone