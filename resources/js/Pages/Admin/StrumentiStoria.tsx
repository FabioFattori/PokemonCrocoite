import React from 'react'
import { buttons, setTableToUse } from '../../utils/buttons';
import userMode from '../../Components/userMode';
import SideBar from '../../Components/SideBar';
import GeneralTable from '../../Components/GeneralTable';
import { usePage } from '@inertiajs/react';

function StrumentiStoria() {
    
        var storyTools = (usePage().props.storyTools as any[]) ?? null;
        setTableToUse("storyTools");
    
        React.useEffect(() => {
            console.log(storyTools);
        },[]);
    
        return (
            <>
            <SideBar title={"Strumenti inerenti alla storia"} mode={userMode.admin}/>
            <GeneralTable tableTitle='Strumenti della storia' dbObject={storyTools} buttons={buttons} />
            </>
        )
  
}

export default StrumentiStoria