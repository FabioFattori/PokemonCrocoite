import { usePage } from "@inertiajs/react";
import GeneralTable from "../../Components/GeneralTable";
import { buttons,setTableToUse,addNewInterractableButton,resetButtonsConfiguration } from "../../utils/buttons";
import SideBar from "../../Components/SideBar";
import userMode from "../../Components/userMode";
import RadarIcon from '@mui/icons-material/Radar';
import React from "react";

enum DependeciesToSolve {
    box_id = "box_id",
    npc_id = "npc_id",
    team_id = "team_id",
    user_id = "user_id"
}

function Esemplari() {
    
    var exemplaries = (usePage().props.exemplaries as any[]) ?? null;
    setTableToUse("exemplaries");

    const [selectedRow,setSelectedRow] = React.useState<any>(null);
    let dependecies = usePage().props.dependencies ?? null;

    
    
    
    React.useEffect(() => {
        addNewInterractableButton("Show Position",RadarIcon,({props}:{props:any}) => {
            let selection = props[0];
            setSelectedRow(selection);
            //scroll to key="dettagli" element
            let element = document.querySelector("h1[key='dettagli']");
            if(element != null){
                element.scrollIntoView({behavior:"smooth"});
            }
        });
        return () => {
            resetButtonsConfiguration()
        }
    },[]);

    let resolveDependencies = (columnName:DependeciesToSolve,column:any) => {
        switch (columnName) {
            case DependeciesToSolve.box_id:
                let boxname = (dependecies as any)["Box"].filter((box: any) => box["id"] == column)[0]["name"];
                return boxname;
            case DependeciesToSolve.npc_id:
                return column;
            case DependeciesToSolve.team_id:
                let team = (dependecies as any)["Team"].filter((team: any) => team["id"] == column)[0];
                let userName = (dependecies as any)["User"].filter((user: any) => user["id"] == team["user_id"])[0]["email"];
                userName = userName.split("@")[0];
                return userName;
            case DependeciesToSolve.user_id:
                column = (dependecies as any)["Box"].filter((box: any) => box["id"] == column)[0]["user_id"]
                let user = (dependecies as any)["User"].filter((user: any) => user["id"] == column)[0];
                return user["email"].split("@")[0];
            default:
                break;
        }
    }

    return (
        <>
            <SideBar title={"Esemplari"} mode={userMode.admin}/>
            <GeneralTable
                tableTitle="Esemplari"
                dbObject={exemplaries}
                buttons={buttons}
            />
            {selectedRow != null ? <div>
                <h1 className="Title" key ="dettagli">Dettagli sulla Posizione</h1>
                {selectedRow["box_id"] != null ? "nel box "+resolveDependencies(DependeciesToSolve.box_id,selectedRow["box_id"])+" di "+resolveDependencies(DependeciesToSolve.user_id,selectedRow["box_id"]) : null}
                {selectedRow["npc_id"] != null ? "in possesso di : "+resolveDependencies(DependeciesToSolve.npc_id,selectedRow["box_id"]) : null}
                {selectedRow["team_id"] != null ? "nel team di : "+resolveDependencies(DependeciesToSolve.team_id,selectedRow["team_id"]) : null}
            </div> : null}

            
        </>
    );
}

export default Esemplari;
