import { router, usePage } from "@inertiajs/react";
import GeneralTable from "../../Components/GeneralTable";
import { Button, setTableToUse } from "../../utils/buttons";
import SideBar from "../../Components/SideBar";
import userMode from "../../Components/userMode";
import OutboxIcon from '@mui/icons-material/Outbox';
import React from "react";

function Box() {
    var boxes = (usePage().props.boxes as any[]) ?? null;
    setTableToUse("boxes");

    let btn = [{
        label: "Mostra Pokemon all'interno", icon: OutboxIcon, method:({ props }: { props: any }) => {
            router.get("/user/exemplariesInBox", { box_id: props[0].id });
        }
    }] as unknown as Button[];

    React.useEffect(() => {
        console.log(window.location.href);
    },[]);

    return (
        <>
            <SideBar title={"Tutti i tuoi Box"} mode={userMode.user}/>
            <GeneralTable
                tableTitle="Box"
                dbObject={boxes}
                buttons={btn}
            />
        </>
    );
  
}

export default Box