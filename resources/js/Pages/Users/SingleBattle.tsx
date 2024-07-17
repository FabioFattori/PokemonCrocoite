import { router, usePage } from "@inertiajs/react";
import GeneralTable from "../../Components/GeneralTable";
import { Button, setTableToUse } from "../../utils/buttons";
import SideBar from "../../Components/SideBar";
import userMode from "../../Components/userMode";
import OutboxIcon from '@mui/icons-material/Outbox';
import DBRowDisplayer from "../../Components/DBRowDisplayer";
import React from "react";

function SingleBattle() {
    let battle_id = usePage().props.battle_id as number;
    var battles = (usePage().props.battles as any[]) ?? null;
    let exe = usePage().props.exemplary as any[] ?? [];
    setTableToUse("battles");

    let btn = [{
        label: "Mostra dettagli esemplare", icon: OutboxIcon, method:({ props }: { props: any }) => {
            router.get("/user/singleBattle", { id: battle_id, exemplary_id: props[0] });
        }
    }] as unknown as Button[];

    React.useEffect(() => {
        console.log(exe);
    },[]);

    return (
        <>
            <SideBar title={"singole battaglie tra pokemon della battaglia selezionata"} mode={userMode.user}/>
            <GeneralTable
                tableTitle="Battaglie tra pokemon"
                dbObject={battles}
                buttons={btn}
            />
            {exe.map((exemplary,index) => {
                return <DBRowDisplayer dbObject={exemplary} Title={"Exemplary "+(index+1)} id={index+""} />;
            })}
        </>
    );
  
}

export default SingleBattle