import { usePage } from '@inertiajs/react';
import { buttons, setTableToUse } from '../../utils/buttons';
import SideBar from '../../Components/SideBar';
import GeneralTable from '../../Components/GeneralTable';
import userMode from '../../Components/userMode';
import React from 'react';

function Generi() {
    var genders = (usePage().props.genders as any[]) ?? null;
    setTableToUse("genders");

    React.useEffect(() => {
        console.log(genders);
    },[]);

    return (
        <>
        <SideBar title={"Generi Pokemon"} mode={userMode.admin}/>
        <GeneralTable tableTitle='Generi' dbObject={genders} buttons={buttons} />
        </>
    )
}

export default Generi