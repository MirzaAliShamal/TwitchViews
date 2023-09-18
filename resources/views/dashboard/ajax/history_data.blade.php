<div class="history">
    @foreach ($orders as $item)
        <div class="history-card strip-{{ $item->status }}">
            <div class="history-channel history-width">
                <div class="history-channel-thumb">
                    <img src="{{ $item->channel_img }}" alt="{{ $item->channel_name }}">
                </div>
                <div class="history-item">
                    <p class="history-name">{{ $item->channel_id }}</p>
                    <p class="history-value">{{ $item->channel_name }}</p>
                </div>
            </div>
            <div class="history-item history-width">
                <p class="history-name">Status:</p>
                <p class="history-value status-{{ $item->status }}">{{ statuses($item->status)['value'] }}</p>
            </div>
            <div class="history-item history-width">
                <p class="history-name">Price:</p>
                <p class="history-value">{{ number_format($item->charge, 2) }}$</p>
            </div>
            <div class="history-item history-width history-right">
                <p class="history-value">Order #{{ $item->id }}</p>
                <p class="history-name">{{ $item->created_at->format('d M, Y H:i') }}</p>
            </div>
            <div class="history-item history-width">
                <p class="history-name">Viewers:</p>
                <p class="history-value">{{ $item->viewers_count }}</p>
            </div>
            <div class="history-item history-width">
                <p class="history-name">Views:</p>
                <p class="history-value">{{ $item->views_done }} <small>from</small> {{ $item->views }}</p>
            </div>
            <div class="history-item history-width"></div>
            <div class="history-item history-width">
            </div>
        </div>
    @endforeach

    @if ($orders->hasPages())
        <div class="history-footer">
            <div class="history-footer-pagination">
                {{ $orders->onEachSide(1)->links() }}
            </div>
        </div>
    @endif
</div>
