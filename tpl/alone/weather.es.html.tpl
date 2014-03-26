?$provincias
	[$provincias]
		<h1>{$locality}, {$weather_now.weatherTime}</h1>

            <div class="weather_now">
                <span style="float:right;"><img src="cid:{$weather_now.weatherIcon}" /></span>
                <strong>DESCRIPTION:</strong> {$weather_now.weatherDesc} <br />
                <strong>TEMPERATURE:</strong> {$weather_now.weatherTemp}<br />
                <strong>WIND SPEED:</strong> {$weather_now.windSpeed} <br />
                <strong>PRECIPITATION:</strong> {$weather_now.precipitation} <br />
                <strong>HUMIDITY:</strong> {$weather_now.humidity}<br />
                <strong>VISIBILITY:</strong> $weather_now.visibility}<br />
                <strong>PRESSURE:</strong> {$weather_now.pressure}<br />
                <strong>CLOUD COVER:</strong> {$weather_now.cloudcover}<br />
            </div>

            <h3>Pron&oacute;stico</h3>

            [$weather_forecast]
                
                <div class="weather_forecast">
                    <div class="block block1">
                        <span class="icon"><img src="{$weatherIcon}" /></span>
                    </div>
                    <div class="block block2">
                        <span class="wday">{$weatherDay}</span>
                        <span class="date">{$weatherDate}</span>
                        <span class="desc">{$weatherDesc}</span>
                        <span class="wind">Viento: {$windDirection} a {$windSpeed}</span>
                    </div>
                    <div class="block block3">
                        <span class="tmax">{$tempMax}</span>
                        <span class="tmin">{$tempMin}</span>
                    </div>
                </div>
            
            [/$weather_forecast]
            
	[/$provincias]
$provincias?

?$satelite
	<h2 style="{$font}">Imagen del Sat&eacute;lite - WSI Corporation</h2>
	<img src="cid:wsi" width="700"><br/>
$satelite?

?$nasa
	<h2 style="{$font}">Imagen del Sat&eacute;lite de la NASA - GOES Project Science</h2>
	<img src="cid:goes" width="700"><br/>
$nasa?

?$radar
	<h2 style="{$font}">Imagen del radar</h2>
	<img src="cid:radar">
	<p style="color:gray;">NOTA: Esta imagen es animada (GIF) y en algunos clientes de correo electr&oacute;nico no se visualiza bien como es el caso de Outlook 2010.</p>
$radar?

?$mapa
	<h2 style="{$font}">Mapa de Presi&oacute;n Superficial</h2>
	<img src="cid:pronostico"><br/>
$mapa?
<br/>
<p>
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA satelite">Imagen del sat&eacute;lite</a> {$splitter} 
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA nasa">Imagen de la NASA </a> {$splitter}
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA radar">Imagen del radar</a> {$splitter} 
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA mapa">Mapa de presi&oacute;n superficial</a>
</p>
<hr/>
