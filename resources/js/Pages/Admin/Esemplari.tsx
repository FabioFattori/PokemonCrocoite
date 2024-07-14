import { router, usePage } from "@inertiajs/react";
import GeneralTable from "../../Components/GeneralTable";
import {
    buttons,
    setTableToUse,
    addNewInterractableButton,
    resetButtonsConfiguration,
    Button,
    MethodButton,
} from "../../utils/buttons";
import SideBar from "../../Components/SideBar";
import userMode from "../../Components/userMode";
import RadarIcon from "@mui/icons-material/Radar";
import React from "react";
import SignLanguageIcon from "@mui/icons-material/SignLanguage";
import SwipeIcon from "@mui/icons-material/Swipe";
import ExemplaryMoveForm from "../../Components/AdminComponents/ExemplaryMoveForm";
import LocationOnIcon from '@mui/icons-material/LocationOn';

enum DependeciesToSolve {
    box_id = "box_id",
    npc_id = "npc_id",
    team_id = "team_id",
    user_id = "user_id",
}

function Esemplari() {
    var exemplaries = (usePage().props.exemplaries as any[]) ?? null;
    setTableToUse("exemplaries");
    var moves = (usePage().props.moves as any[]) ?? null;
    var allMoves = (usePage().props.allLearnableMoves as any[]) ?? null;

    const [selectedRow, setSelectedRow] = React.useState<any>(null);
    let dependecies = usePage().props.dependencies ?? null;

    const [open, setOpen] = React.useState(false);
    const [currentMove, setCurrentMove] = React.useState<any>(null);

    const closeDialog = () => {
        setOpen(false);
    }

    const openDialog = () => {
        setOpen(true);
    }

    React.useEffect(() => {
        addNewInterractableButton(
            "Show Position",
            RadarIcon,
            ({ props }: { props: any }) => {
                let selection = props[0];
                setSelectedRow(selection);
                //scroll to key="dettagli" element
                let element = document.querySelector("h1[key='dettagli']");
                if (element != null) {
                    element.scrollIntoView({ behavior: "smooth" });
                }
            }
        );
        addNewInterractableButton(
            "Show Moves",
            SignLanguageIcon,
            ({ props }: { props: any }) => {
                let selection = props[0];
                router.get("/admin/exemplaries", {
                    exemplary_id: selection["id"],
                });
            }
        );
        return () => {
            resetButtonsConfiguration();
        };
    }, []);

    let resolveDependencies = (columnName: DependeciesToSolve, column: any) => {
        switch (columnName) {
            case DependeciesToSolve.box_id:
                let boxname = (dependecies as any)["Box"].filter(
                    (box: any) => box["id"] == column
                )[0]["name"];
                return boxname;
            case DependeciesToSolve.npc_id:
                console.log(column);
                let npc = (dependecies as any)["Npc"].filter((npc: { [x: string]: any; })=> npc["id"] == column)[0];
                return npc["name"];
            case DependeciesToSolve.team_id:
                let team = (dependecies as any)["Team"].filter(
                    (team: any) => team["id"] == column
                )[0];
                let userName = (dependecies as any)["User"].filter(
                    (user: any) => user["id"] == team["user_id"]
                )[0]["email"];
                userName = userName.split("@")[0];
                return userName;
            case DependeciesToSolve.user_id:
                column = (dependecies as any)["Box"].filter(
                    (box: any) => box["id"] == column
                )[0]["user_id"];
                let user = (dependecies as any)["User"].filter(
                    (user: any) => user["id"] == column
                )[0];
                return user["email"].split("@")[0];
            default:
                break;
        }
    };

    return (
        <>
            <SideBar title={"Esemplari"} mode={userMode.admin} />
            <GeneralTable
                tableTitle="Esemplari"
                dbObject={exemplaries}
                buttons={buttons}
            />
            {selectedRow != null ? (
                <div className="PositionDetails">
                    <h1 className="Title" key="dettagli">
                        Dettagli sulla Posizione <LocationOnIcon />
                    </h1>
                    <p className="paragraphPosition">{selectedRow["box_id"] != null
                        ? "nel box " +
                          resolveDependencies(
                              DependeciesToSolve.box_id,
                              selectedRow["box_id"]
                          ) +
                          " di " +
                          resolveDependencies(
                              DependeciesToSolve.user_id,
                              selectedRow["box_id"]
                          )
                        : null}
                    {selectedRow["npc_id"] != null
                        ? "in possesso dell'Npc di nome : " +
                          resolveDependencies(
                              DependeciesToSolve.npc_id,
                              selectedRow["npc_id"]
                          )
                        : null}
                    {selectedRow["team_id"] != null
                        ? "nel team del giocatore : " +
                          resolveDependencies(
                              DependeciesToSolve.team_id,
                              selectedRow["team_id"]
                          )
                        : null}</p>
                </div>
            ) : null}
            {moves != null ? (
                <>
                <GeneralTable
                    tableTitle="Mosse del Pokemon selezionato"
                    dbObject={moves}
                    buttons={
                        [
                            {
                                label: "Edit Move",
                                icon: SwipeIcon,
                                method: ({ props }: { props: any }) => {
                                    setCurrentMove(props[0]);
                                    openDialog();
                                },
                            } as MethodButton,
                        ] as Button[]
                    }
                />
                <ExemplaryMoveForm isOpen={open} closeDialog={closeDialog} openDialog={openDialog} exemplary_id={selectedRow==null?window.location.href.split("exemplary_id=")[1]!=null?window.location.href.split("exemplary_id=")[1]:null:selectedRow["id"]} moves={currentMove} allLearnableMoves={allMoves}/>
                </>
            ) : null}
        </>
    );
}

export default Esemplari;
