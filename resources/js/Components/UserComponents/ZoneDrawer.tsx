import { usePage } from "@inertiajs/react";
import React, { useRef } from "react";

function ZoneDrawer() {
    const [updated, setUpdated] = React.useState(false);
    const chooseRandomColor = () => {
        const colors = [
            "#FF5733", // Rosso arancio
            "#33FF57", // Verde
            "#3357FF", // Blu
            "#FF33A6", // Rosa
            "#33FFF0", // Turchese
            "#FF8C33", // Arancione
            "#8C33FF", // Viola
            "#FF33FF", // Magenta
            "#33FF8C", // Verde chiaro
            "#5733FF", // Blu scuro
            "#FFD700", // Oro
            "#FF4500", // Arancione rosso
            "#00FF00", // Verde lime
            "#00CED1", // Turchese scuro
            "#9400D3", // Viola scuro
            "#8B0000", // Rosso scuro
            "#00008B", // Blu scuro
            "#556B2F", // Verde oliva scuro
            "#FF1493", // Rosa acceso
            "#FF6347", // Rosso pomodoro
            "#7FFF00", // Chartreuse
            "#6495ED", // Blu fiordaliso
            "#DC143C", // Cremisi
            "#2E8B57", // Verde mare
            "#FF7F50", // Corallo
            "#8A2BE2", // Blu violetto
            "#FFDEAD", // Bianco navajo
            "#5F9EA0", // Blu cadetto
            "#FFDAB9", // Pesca
            "#FA8072", // Salmone
            "#7B68EE", // Blu ardesia medio
            "#00FA9A", // Verde primavera medio
            "#D2691E", // Cioccolato
            "#FFB6C1", // Rosa chiaro
            "#4682B4", // Blu acciaio
            "#32CD32", // Verde lime
            "#FF00FF", // Fucsia
            "#F0E68C", // Khaki
            "#B22222", // Rosso mattone
            "#20B2AA", // Verde acqua chiaro
            "#FF69B4", // Rosa caldo
            "#CD5C5C", // Rosso indiano
            "#FFD700", // Oro
            "#ADFF2F", // Verde giallastro
            "#FF4500", // Arancione rosso
            "#DA70D6", // Orchidea
            "#1E90FF", // Blu dodger
            "#B0C4DE", // Blu pallido
            "#FFA07A", // Salmone chiaro
            "#E9967A", // Salmone scuro
            "#8FBC8F", // Verde mare scuro
            "#483D8B", // Blu ardesia scuro
            "#00FF7F", // Verde primavera
            "#4682B4", // Blu acciaio
            "#D2B48C", // Tan
            "#A52A2A", // Marrone
            "#FF6347", // Rosso pomodoro
            "#DAA520", // Goldenrod
            "#4B0082", // Indaco
            "#40E0D0", // Turchese
            "#F4A460", // Sabbia
            "#8A2BE2", // Blu violetto
            "#7FFF00", // Chartreuse
            "#DDA0DD", // Prugna
            "#BC8F8F", // Rosso cadmio
            "#FF00FF", // Magenta
            "#F0FFFF", // Acquamarina
        ];
        let color = colors[Math.floor(Math.random() * colors.length)];
        return color;
    };

    const canvasRef = useRef<HTMLCanvasElement>(null);
    let zones = usePage().props.zones as any[];
    React.useEffect(() => {
        const canvas = canvasRef.current;
        if (canvas) {
            const context = canvas.getContext("2d");
            if (context && updated === false) {
                zones.forEach((singleZone) => {
                    console.log(singleZone);
                    context.fillStyle = chooseRandomColor();
                    singleZone["color"] = context.fillStyle;
                    context.fillRect(
                        singleZone["position"]["x"],
                        singleZone["position"]["y"],
                        singleZone["width"],
                        singleZone["length"]
                    );
                    let divToColor = document.getElementById("zone") as HTMLInputElement;
                    
                    if(divToColor){
                        let arr = divToColor.value ;
                        arr = arr + singleZone["color"] + ",";
                        divToColor.value = arr;
                        console.log(divToColor.value);
                    }
                });
            }
            setUpdated(true);
        }
    }, [updated]);

    return (
        <>
        <input type="hidden" id="zone" value={""} />
            <canvas
                style={{
                    marginTop: "80px",
                    backgroundColor: "grey",
                    width: "100%",
                    imageRendering: "pixelated",
                }}
                ref={canvasRef}
            />
            <div
                style={{
                    position: "absolute",
                    top: 100,
                    right: 0,
                    backgroundColor: "white",
                    borderRadius: "20px",
                    padding: "10px",
                    marginRight: "5px",
                }}
            >
                <h1 className="Title">Legenda</h1>
                <ul>
                    {zones.map((zone,index) => (
                        <li
                            key={zone.id}
                            style={{ display: "flex", alignItems: "center" }}
                        >
                            <div
                                style={{
                                    backgroundColor: (document.getElementById("zone") as HTMLInputElement)?.value.split(",")[index],
                                    width: "40px",
                                    height: "40px",
                                    margin: "10px",
                                    borderRadius: "50%",
                                    color:(document.getElementById("zone") as HTMLInputElement)?.value.split(",")[index],
                                    border: "2px dashed black",
                                }}
                            >
                                --
                            </div>
                            {zone.name} - x: {zone.position.x} - y:
                            {zone.position.y}
                        </li>
                    ))}
                </ul>
            </div>
        </>
    );
}

export default ZoneDrawer;
