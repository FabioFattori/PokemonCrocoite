import React from 'react'
import { usePage } from '@inertiajs/react';
import { buttons, setTableToUse } from '../../utils/buttons';
import SideBar from '../../Components/SideBar';
import GeneralTable from '../../Components/GeneralTable';
import userMode from '../../Components/userMode';

function OggettiDaBattaglia() {
    var tools = (usePage().props.tools as any[]) ?? null;
    setTableToUse("tools");

    React.useEffect(() => {
        console.log(tools);
    },[]);

    return (
        <>
        <SideBar title={"Oggetti da Battaglia"} mode={userMode.admin}/>
        <GeneralTable tableTitle='Oggetti' dbObject={tools} buttons={buttons} />
        </>
    )
}

export default OggettiDaBattaglia