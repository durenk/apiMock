@extends('site/layouts/master')

@section('content')

  <div class="presentation">
    <h1>{{ trans("presentation.app_name") }}</h1>
    <h2>{{ trans("presentation.baseline") }}</h2>
    <pre>&gt; PUT {{ url('<span>{id}</span>') }}</pre>
    <pre>
      &lt; HTTP/1.1 200 OK
      &lt; Content-Type: application/json; charset=UTF-8
      { "<span>hello</span>": "<span>world</span>" }
    </pre>
  </div>

  <form class="form-horizontal" action="{{ url('submit') }}" method="post" id="new-mocky-form">

    @if(isset($error_messages))
      <div class="alert alert-error">{{ trans("error.invalid_form"). " : " . $error_messages }}</div>
    @endif

    <div class="alert" id="feedback">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <p></p> <!--Do not remove...-->
    </div>
    <div class="alert alert-info" id="confidential-alert">
      {{ trans("news.jsonp") }}
    </div>

    <fieldset>
      <legend>{{ trans("form.legend") }}</legend>

      <div class="control-group">
        <label class="control-label" for="statusCode">{{ trans("form.code") }}</label>
        <div class="controls">
          <input type="text" id="statusCode" name="code"  />
        </div>
      </div>
      <div class="control-group hide" id="location-block">
        <label class="control-label" for="location">{{ trans("form.location") }}</label>
        <div class="controls">
          <input type="text" id="location" name="redirect_location" placeholder="Redirect URI" class="input-xlarge" />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="contentType">{{ trans("form.content_type") }}</label>
        <div class="controls">
          <input type="text" id="contentType" name="content_type" />
          &nbsp;
          <input type="text" id="charset" name="charset" />
        </div>
      </div>

      <div class="advanced-block hide">
        <div class="control-group">
          <label class="control-label" for="editor">{{ trans("form.custom_headers") }}</label>
          <div class="controls" id="advanced-block-inner">
            <p class="clone">
              <input class="span2" type="text" name="headerNames[]"> :
              <input class="span4" type="text" name="headerValues[]">
              <a class="btn btn-success btn-mini btn-add-header"><i class="icon icon-plus icon-white"></i></a>
            </p>
          </div>
          <div class="controls">
            <span class="help-block">{{ trans("eg") }} ETag, If-None-Match, Expires, Last-Modified, Server, X-Cache, Cache-Control,<br /> X-Frame-Options, Server, Set-Cookie, X-UA-Compatible...</span>
          </div>
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="editor">{{ trans("form.body") }}</label>
        <div class="controls">
          <textarea name="body" id="editor"></textarea>
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary" id="send-btn">{{ trans("btn.generate") }}</button>
          <a href="#" class="btn btn-advanced-mode">{{ trans("btn.advanced") }}</a>
        </div>
      </div>
    </fieldset>
  </form>

@stop

@section('scripts')

<script>
  $(function() {

      $("#statusCode").select2({
          createSearchChoice: function(term, data) { if ($(data).filter(function() { return this.text.localeCompare(term)===0; }).length===0) {return {id:term, text:term};} },
          multiple: false,
          width: "element",
          data: {{ Referentials::mappingIdName('codes') }}
      })
      $("#statusCode").select2('data', {id: 200, text:"200 OK"})

      $("#charset").select2({
          createSearchChoice: function(term, data) { if ($(data).filter(function() { return this.text.localeCompare(term)===0; }).length===0) {return {id:term, text:term};} },
          multiple: false,
          width: "element",
          data: {{ Referentials::mappingIdName('charsets') }}
      })
      $("#charset").select2('data', { id: "UTF-8", text: "UTF-8" })

      $("#contentType").select2({
          createSearchChoice: function(term, data) { if ($(data).filter(function() { return this.text.localeCompare(term)===0; }).length===0) {return {id:term, text:term};} },
          multiple: false,
          width: "element",
          data: {{ Referentials::mappingIdName('contentTypes') }}
      })
      $("#contentType").select2('data', { id: "application/json", text: "application/json" })

      $("#new-mocky-form").on('submit', function(e) {
          e.preventDefault();
          // _gaq.push(['_trackEvent', 'apiMock', 'create', 'api mock requested', , false]);
          $("#send-btn").text('{{ trans("btn.wait") }}').attr("disabled", "disabled")
          var body = $(this).serializeArray()
          $.post("{{ url('submit') }}", body)
              .done(function(data) {
                  // _gaq.push(['_trackEvent', 'apiMock', 'success', 'api mock created with success', , false]);
                  $("#feedback p").html('<strong>'+'{{ trans("alert.link_ready") }}'+'</strong> <a href="'+data.url+'" target="blank">'+data.url+'</a>')
                  $("#feedback").addClass("alert-success").removeClass("alert-error");
              })
              .fail(function() {
                  // _gaq.push(['_trackEvent', 'apiMock', 'failed', 'error when creating api mock', , false]);
                  $("#feedback p").html('{{ trans("error.retry") }}')
                  $("#feedback").addClass("alert-error").removeClass("alert-success");
              })
              .always(function() {
                  $("#send-btn").text('{{ trans("btn.generate") }}').attr("disabled", null)
                  $("#feedback").show()
                  $("#confidential-alert").hide()
              })
      })

      $("#statusCode").on("change", function() {
          var code = $(this).val()
          if (code.length > 0 && code[0]=="3") {
              $("#location-block").show();
          } else {
              $("#location-block").hide().find("input").val("")
          }
      })

      $(".btn-advanced-mode").on("click", function(e) {
          e.preventDefault()
          var $block = $(".advanced-block")
          if ($block.is(":visible")) {
              $block.hide();
              $(".btn-advanced-mode").text('{{ trans("btn.advanced") }}')
          } else {
              $block.show();
              $(".btn-advanced-mode").text('{{ trans("btn.basic") }}')
          }
      })

      $("#advanced-block-inner").on("click", ".btn-add-header", function(e) {
          e.preventDefault()
          var $context = $("#advanced-block-inner")
          var origin = $context.find(".clone")
          var clone = origin.clone()
          clone.find("input[type=text]").each(function() { $(this).val("") })
          $context.append(clone)
          origin.removeClass("clone")
          $(this).remove()
      })

  });
</script>

@stop