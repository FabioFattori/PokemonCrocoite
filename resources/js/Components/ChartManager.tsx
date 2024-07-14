import React from "react"
import { AxisOptions, Chart } from "react-charts"

type PianoCartesiano = {
    x:any,
    y:any
}

function ChartManager({title,label,x,y}:{title:string,label:string,x:any[],y:any[]}) {

    React.useEffect(() => {
        if(x.length == y.length){
            let data = [];
            
            for (let index = 0; index < y.length; index++) {
                data.push({label:x[index],data:[{x:x[index],y:y[index]}]})
            }
            setData(data)

        }else{
            console.log(title)
            console.log(x)
            console.log(y)
            throw new Error("x and y must have the same length, received instead x=>"+x+"\n y=>"+y)
        }
    },[x, y]) // Added 'y' to the dependency array to ensure useEffect runs when either 'x' or 'y' changes.

    const [data,setData] = React.useState<any>([{label:"",data:[{x:0,y:0}]}])

    
    
    const primaryAxis = React.useMemo(
        (): AxisOptions<PianoCartesiano> => ({
          getValue: datum => datum.x,
        }),
        []
      )
    
      const secondaryAxes = React.useMemo(
        (): AxisOptions<PianoCartesiano>[] => [
          {
            getValue: datum => datum.y,
          },
        ],
        []
      )
  return (
    <div className="chart">
        <h1>
            {title}
        </h1>
        {x.length != 0 && x.length == y.length ?<Chart
        options={{
            data,
            primaryAxis,
            secondaryAxes,
        }}
        /> : null}
     </div>
  )
}

export default ChartManager