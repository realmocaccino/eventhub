export function useFormattedDate() {
  const formatDate = (dateString) => {
    const date = new Date(dateString);

    return {
      date: date.toLocaleDateString(),

      time: date.toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit'
      }),

      full: date.toLocaleDateString('en-US', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
      }),
    };
  };

  return { formatDate };
}