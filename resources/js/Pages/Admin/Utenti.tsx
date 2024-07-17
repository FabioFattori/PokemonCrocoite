import GeneralTable from "../../Components/GeneralTable";
import SideBar from "../../Components/SideBar";
import {
    addNewInterractableButton,
    Button,
    buttons,
    resetButtonsConfiguration,
    setTableToUse,
} from "../../utils/buttons";
import { router, usePage } from "@inertiajs/react";
import userMode from "../../Components/userMode";
import React from "react";
import BackpackIcon from "@mui/icons-material/Backpack";
import Delete from "@mui/icons-material/Delete";
import AddIcon from "@mui/icons-material/Add";
import Edit from "@mui/icons-material/Edit";
import ExpandCircleDownIcon from "@mui/icons-material/ExpandCircleDown";
import CatchingPokemonIcon from '@mui/icons-material/CatchingPokemon';

function Utenti() {
    var users = (usePage().props.users as any[]) ?? null;
    let tools = (usePage().props.tools as any[]) ?? null;
    let storyTool = (usePage().props.storyTool as any[]) ?? null;
    let mnMt = (usePage().props.mnMt as any[]) ?? null;
    let btnsInvetory = [
        { label: "Add", icon: AddIcon, url: null },
        { label: "Edit", icon: Edit, url: null },
        {
            label: "Delete",
            icon: Delete,
            url: !window.location.href.includes("Delete")
                ? window.location.href.split("?user_id")[0] +
                  "/Delete?user_id=" +
                  window.location.href.split("?user_id=")[1]
                : window.location.href,
        },
    ] as Button[];

    let btnsToolsStory = [
        { label: "Add", icon: AddIcon, url: null },
        { label: "Edit", icon: Edit, url: null },
        {
            label: "Delete",
            icon: Delete,
            url: !window.location.href.includes("Delete")
                ? window.location.href.split("?user_id")[0] +
                  "/Delete?user_id=" +
                  window.location.href.split("?user_id=")[1] 
                : window.location.href,
        },
    ] as Button[];

    let btnsMnMt = [
        { label: "Add", icon: AddIcon, url: null },
        { label: "Edit", icon: Edit, url: null },
        {
            label: "Delete",
            icon: Delete,
            url: !window.location.href.includes("Delete")
                ? window.location.href.split("?user_id")[0] +
                  "/Delete?user_id=" +
                  window.location.href.split("?user_id=")[1] 
                : window.location.href,
        },
    ] as Button[];
  

    setTableToUse("users");
    React.useEffect(() => {
        addNewInterractableButton(
            "Mostra Invetario",
            BackpackIcon,
            ({ props }: { props: any }) => {
                router.get("/admin/users", { user_id: props[0].id });
            }
        );
        addNewInterractableButton(
          "Mostra Team",
          ExpandCircleDownIcon,
          ({ props }: { props: any }) => {
              router.get("/admin/teams", { user_id: props[0].id });
          }
      );

      addNewInterractableButton(
        "Mostra Catture",
        CatchingPokemonIcon,
        ({ props }: { props: any }) => {
            router.get("/admin/captures", { user_id: props[0].id });
        }
    );
       
    
        return () => {
            resetButtonsConfiguration();
        };
    }, []);
    return (
        <>
            <SideBar title={"Utenti"} mode={userMode.admin} />
            <GeneralTable
                tableTitle="Utenti"
                dbObject={users}
                buttons={buttons}
            />
            {tools != null || storyTool != null || mnMt != null ? <h1 style={{display:"flex",justifyContent:"center"}} className="Title">Inventario</h1>:null}
            {tools != null ? (
                <GeneralTable
                    tableTitle="Oggetti da Battaglia"
                    rootForPagination={window.location.href}
                    dbObject={tools}
                    buttons={btnsInvetory}
                />
            ) : null}
            {storyTool != null ?
                <GeneralTable
                    tableTitle="Strumenti inerenti alla storia"
                    rootForPagination={window.location.href}
                    dbObject={storyTool}
                    buttons={btnsToolsStory}
                />
            :null}
            {mnMt != null ?
                <GeneralTable
                    tableTitle="Mn e Mt"
                    rootForPagination={window.location.href}
                    dbObject={mnMt}
                    buttons={btnsMnMt}
                />
            :null}
        </>
    );
}

export default Utenti;
