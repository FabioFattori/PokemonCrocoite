import GeneralTable from '../../Components/GeneralTable'
import SideBar from '../../Components/SideBar';
import { buttons } from '../../utils/buttons';
import { usePage } from '@inertiajs/react';

function Utenti() {
    var users = (usePage().props.users as any[]) ?? null;
  return (
    <>
    <SideBar title={"Utenti"}/>
    <GeneralTable tableTitle='Utenti' dbObject={users} buttons={buttons} />
    </>
  )
}

export default Utenti