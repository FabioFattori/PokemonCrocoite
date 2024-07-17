import { usePage } from '@inertiajs/react';
import { buttons, setTableToUse } from '../../utils/buttons';
import SideBar from '../../Components/SideBar';
import GeneralTable from '../../Components/GeneralTable';
import userMode from '../../Components/userMode';
import React from 'react';

function Catture() {
    var captures = (usePage().props.captures as any[]) ?? null;
    setTableToUse("captures");

    React.useEffect(() => {
        console.log(Error);
    },[]);

    return (
        <>
        <SideBar title={"Catture effettuate dall'utente selezionato"} mode={userMode.admin}/>
        <GeneralTable tableTitle='Catture' dbObject={captures} buttons={buttons} />
        
        </>
    )
  
}

export default Catture