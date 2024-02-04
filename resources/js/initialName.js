

function initailName(string){
    const name = string.split(' ')
      return `${name[0].charAt(0)}${name[1] ? name[1].charAt(0) : ''}`;
}

export default initailName;