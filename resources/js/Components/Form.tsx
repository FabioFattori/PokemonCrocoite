

function Form({headers=[] , data=[]}:{headers: string[], data: any[]}) {
  return (
    <>
        {headers.map((header, index) => {
            return <div key={index}>{header + data[index]}</div>
        })}
    </>
  )
}

export default Form