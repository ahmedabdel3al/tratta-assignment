export const communicationUsage = async (params) => {
    try {
        const {data} = await axios.get('/api/communication', { params: params })
        return data.data
    } catch (e) {
        return {}
    }
}
