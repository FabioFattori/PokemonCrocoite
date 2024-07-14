import { usePage } from '@inertiajs/react';
import React from 'react'
import { buttons, setTableToUse } from '../../utils/buttons';
import userMode from '../../Components/userMode';
import SideBar from '../../Components/SideBar';
import GeneralTable from '../../Components/GeneralTable';

function Effectivnesses() {
    var eff = (usePage().props.effectivnesses as any[]) ?? null;
    setTableToUse("effectivnesses");

    React.useEffect(() => {
    },[]);

    return (
        <>
        <SideBar title={"Effetti Pokemon"} mode={userMode.admin}/>
        <GeneralTable tableTitle='Effetti' dbObject={eff} buttons={buttons} />
        </>
    )
}

export default Effectivnesses