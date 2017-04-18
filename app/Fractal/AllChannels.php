use App\Channel;
use League\Fractal\TransformerAbstract;

class AllChannels extends TransformerAbstract
{
	public function transform(Channel $channel)
	{
		return [
			'id' => $channel->id,
            'slug' => $channel->slug,
			'name' => $channel->name,
			'hidden' => $channel->is_hidden,
            'order' => $channel->order,
            'thread_count' => $channel->threads_count,
            'reply_count' => $channel->threads()->replies->count(),
            'editing' => false,
		];
	}
}