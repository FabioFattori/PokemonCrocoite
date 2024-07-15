import GeneralTable from '../../Components/GeneralTable'
import SideBar from '../../Components/SideBar';
import { addNewInterractableButton, Button, buttons,resetButtonsConfiguration,setTableToUse} from '../../utils/buttons';
import { router, usePage } from '@inertiajs/react';
import userMode from '../../Components/userMode';
import React from 'react';
import BackpackIcon from '@mui/icons-material/Backpack';
import Delete from '@mui/icons-material/Delete';
import AddIcon from '@mui/icons-material/Add';
import  Edit  from "@mui/icons-material/Edit";


function Utenti() {
    var users = (usePage().props.users as any[]) ?? null;
    let tools = (usePage().props.tools as any[]) ?? null;
    let btnsInvetory = [
      { label:"Add", icon: AddIcon, url: null },{label:"Edit", icon: Edit, url: null },{label:"Delete", icon: Delete, url: !window.location.href.includes("Delete")?window.location.href.split("?user_id")[0]+"/Delete?user_id="+window.location.href.split("?user_id=")[1]:window.location.href}
  ] as Button[];
    setTableToUse("users");
    React.useEffect(() => {
      addNewInterractableButton("Mostra Invetario",BackpackIcon,({ props }: { props: any })=>{
          router.get("/admin/users",{user_id:props[0].id})
      })
      return () => {
          resetButtonsConfiguration();
      }
  }, []);
  return (
    <>
    <SideBar title={"Utenti"} mode={userMode.admin}/>
    <GeneralTable tableTitle='Utenti' dbObject={users} buttons={buttons} />
    {tools != null ? <GeneralTable tableTitle="Inventario dell'utente" rootForPagination={window.location.href} dbObject={tools} buttons={btnsInvetory}  /> :null}
    </>
  )
}

export default Utenti