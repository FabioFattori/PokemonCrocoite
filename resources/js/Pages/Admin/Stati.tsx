import React from 'react'
import { buttons, setTableToUse } from '../../utils/buttons';
import userMode from '../../Components/userMode';
import SideBar from '../../Components/SideBar';
import GeneralTable from '../../Components/GeneralTable';
import { usePage } from '@inertiajs/react';



function Stati() {
    var states = (usePage().props.states as any[]) ?? null;
    setTableToUse("states");

    React.useEffect(() => {
        console.log(states);
    },[]);

    return (
        <>
        <SideBar title={"Stati Pokemon"} mode={userMode.admin}/>
        <GeneralTable tableTitle='Stati' dbObject={states} buttons={buttons} />
        </>
    )
  
}

export default Stati