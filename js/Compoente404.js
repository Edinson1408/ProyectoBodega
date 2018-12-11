class Page404 extends React.Component
{
    render(){
        return(
            <div>
                <embed src="../php/404/homero.mp3" autostart='false true' loop='true' hidden='true' />
                <div class="wrapper row2">
                    <div id="container" className="clear">
                        
                        <section id="fof" className="clear">
                        <div className="positioned">
                            <div className="hgroup">
                            <h1>404 Error</h1>
                            <h2>DOH! Page Not Found</h2>
                            <h2>Acceso Denegado</h2>
                            </div>
                        </div>
                        </section>
                    </div>
                </div>
            </div>
        );
    }
}


function Rendiza(nomdiv)
{
    ReactDOM.render(
        <Page404 />,
        document.getElementById(nomdiv)
      );
}
    
