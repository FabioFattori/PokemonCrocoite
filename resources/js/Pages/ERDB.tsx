import { CircularProgress, Fade, IconButton, Stack } from "@mui/material";
import mermaid from "mermaid";
import { useEffect, useRef, useState } from "react";
import { TransformComponent, TransformWrapper, useControls } from "react-zoom-pan-pinch";
import AddCircleRoundedIcon from '@mui/icons-material/AddCircleRounded';
import RemoveCircleRoundedIcon from '@mui/icons-material/RemoveCircleRounded';
import { TrendingUp } from "@mui/icons-material";

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
    const [mermaidReady, setMermaidReady] = useState(false)

    useEffect(() =>
    {
        mermaid.initialize({
            startOnLoad: true, darkMode: true, theme: "dracula"})
        mermaid.contentLoaded()
        setMermaidReady(true)
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
            pinch={{
                step: 2,                
            }}
            smooth={false}
        >
            <Stack>
                <ZoomButtons />
                <TransformComponent >
                    <Fade in={mermaidReady} >
                        <div ref={mermaidDiv} className="mermaid" style={{
                            width: "100vw",
                            height: "100vh",
                            padding:"10px"
                        }}>
                            {props.mermaidCode}
                        </div>
                    </Fade>
                    {
                        !mermaidReady && (
                            <CircularProgress />
                        )
                    }
                
                </TransformComponent>
                </Stack>
        </TransformWrapper>
    )   
}

function ZoomButtons()
{
    const {zoomIn, zoomOut} = useControls()

    return <Stack direction={"row"} sx={{position:"fixed", top:2, left:2, zIndex:9999}}>
        <IconButton onClick={() => zoomIn(1)}>
            <AddCircleRoundedIcon />
        </IconButton>
        <IconButton onClick={() => zoomOut(1)}>
            <RemoveCircleRoundedIcon />
        </IconButton>
    </Stack>
}