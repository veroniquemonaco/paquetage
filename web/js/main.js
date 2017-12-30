const arr = [1,2,3,4,5];

// const arrPlusUn = arr.map(function (nombre) {
//     return `${nombre} + 1 = ${nombre + 1}`;
// });

// const arrPlusUn = arr.map((nombre) => {
//     return `${nombre} + 1 = ${nombre + 1}`;
// });

// const arrPlusUn = arr.map( nombre => {
//     return `${nombre} + 1 = ${nombre + 1}`;
// });

// const arrPlusUn = arr.map( nombre => `${nombre} + 1 = ${nombre + 1}`);

const arrPlusUn = arr.map( () => `5`);

console.log(arrPlusUn);