export function useNameInitials() {
    const getNameInitials = (name) => {
        const words = name.trim().split(/\s+/);

        if (words.length === 1) {
            return words[0].slice(0, 2).toUpperCase();
        }
        
        else {
            return words
            .slice(0, 2)
            .map(word => word[0] || '')
            .join('')
            .toUpperCase();
        }
    };
  
    return { getNameInitials };
  }