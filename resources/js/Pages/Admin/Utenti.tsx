import GeneralTable from '../../Components/GeneralTable'
import SideBar from '../../Components/SideBar';
import { buttons,setTableToUse} from '../../utils/buttons';
import { usePage } from '@inertiajs/react';
import userMode from '../../Components/userMode';
import React from 'react';

function Utenti() {
    var users = (usePage().props.users as any[]) ?? null;
    setTableToUse("users");

  return (
    <>
    <SideBar title={"Utenti"} mode={userMode.admin}/>
    <GeneralTable tableTitle='Utenti' dbObject={users} buttons={buttons} />
    </>
  )
}

export default Utenti