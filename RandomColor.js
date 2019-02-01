var randomColor = require('randomcolor');

var color = randomColor();
tableColor = [color];

for(var i = 0; i < 30 ; i++)
{
    color = randomColor();
    tableColor.push(color);
}

randomColor({
    luminosity: 'light',
    hue: 'random'
});
 
 