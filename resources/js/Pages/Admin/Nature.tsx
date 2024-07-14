import { usePage } from '@inertiajs/react';
import React from 'react'
import { buttons, setTableToUse } from '../../utils/buttons';
import userMode from '../../Components/userMode';
import SideBar from '../../Components/SideBar';
import GeneralTable from '../../Components/GeneralTable';

function Nature() {
    var nature = (usePage().props.natures as any[]) ?? null;
    setTableToUse("natures");

    React.useEffect(() => {
        console.log(nature);
    },[]);

    return (
        <>
        <SideBar title={"Nature Pokemon"} mode={userMode.admin}/>
        <GeneralTable tableTitle='Nature' dbObject={nature} buttons={buttons} />
        </>
    )
}

export default Nature