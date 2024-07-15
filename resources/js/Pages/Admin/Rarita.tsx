import React from 'react'
import { buttons, setTableToUse } from '../../utils/buttons';
import userMode from '../../Components/userMode';
import SideBar from '../../Components/SideBar';
import GeneralTable from '../../Components/GeneralTable';
import { usePage } from '@inertiajs/react';


function Rarita() {
    var rar = (usePage().props.rarities as any[]) ?? null;
    setTableToUse("rarities");

    React.useEffect(() => {
        console.log(rar);
    },[]);

    return (
        <>
        <SideBar title={"Rarità Pokemon"} mode={userMode.admin}/>
        <GeneralTable tableTitle='Rarità' dbObject={rar} buttons={buttons} />
        </>
    )
}

export default Rarita