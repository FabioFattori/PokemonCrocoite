import { Height } from "@mui/icons-material";
import mermaid from "mermaid";
import { useEffect, useRef } from "react";
import { TransformComponent, TransformWrapper } from "react-zoom-pan-pinch";



interface ErDbProps
{
    mermaidCode: string;
}

export default function ErDb(props:ErDbProps)
{

    return (<div style={{
        width: "100vw",
        height: "100vh",
        display: "flex",
        flexDirection: "column",
        alignItems: "center",
        justifyContent:"center"
    }}>
        <Mermaid mermaidCode={props.mermaidCode}/>
    </div>)

}

function Mermaid(props:{mermaidCode:string})
{
    const mermaidDiv = useRef(null);

    useEffect(() =>
    {
        mermaid.initialize({ startOnLoad: true, darkMode:true })
        mermaid.contentLoaded()
        mermaid.mermaidAPI.setConfig({})
    }, [props.mermaidCode])

    return (
        <TransformWrapper
            ref={mermaidDiv}
            initialScale={1}
            minScale={0.5}
            maxScale={20}
            wheel={{
                step: 0.1,
            }}
            doubleClick={{
                disabled: false,
            }}
        >
            <TransformComponent >
                <div ref={mermaidDiv} className="mermaid" style={{
                    width: "100vw",
                    height: "100vh",
                    border: "1px solid black",
                    padding:"10px"
                }}>
                    {props.mermaidCode}
                </div>
            </TransformComponent>
        </TransformWrapper>
    )   
}